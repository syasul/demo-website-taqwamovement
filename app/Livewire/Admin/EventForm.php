<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Models\EventAgendaItem;
use App\Models\EventAudiencePoint;
use App\Models\EventSession;
use App\Models\EventTopic;
use App\Models\Phase;
use App\Models\Speaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class EventForm extends Component
{
    public $event;
    public $isEdit = false;

    // Selection lists
    public $phases = [];
    public $allSpeakers = [];

    // Form inputs
    public $phase_id;
    public $title;
    public $tagline;
    public $description;
    public $date;
    public $location;
    public $ticket_url;
    public $status = 'draft';
    public $meta_title;
    public $meta_description;
    
    // Speaker associations
    public $selectedSpeakers = [];

    // Repeaters data
    public $sessions = [];
    public $agendaItems = [];
    public $topics = [];
    public $audiencePoints = [];

    // Tab active status
    public $activeTab = 'basic';

    protected $rules = [
        'phase_id' => 'required|exists:phases,id',
        'title' => 'required|string|max:255',
        'tagline' => 'nullable|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'location' => 'nullable|string|max:255',
        'ticket_url' => 'nullable|url|max:255',
        'status' => 'required|in:draft,published,archived',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'selectedSpeakers' => 'nullable|array',
        'selectedSpeakers.*' => 'exists:speakers,id',

        // Repeaters validations
        'sessions.*.title' => 'required|string|max:255',
        'sessions.*.session_number' => 'required|integer',
        'sessions.*.description' => 'nullable|string',
        'sessions.*.start_time' => 'nullable|string',
        'sessions.*.end_time' => 'nullable|string',

        'agendaItems.*.title' => 'required|string|max:255',
        'agendaItems.*.session_group' => 'required|integer|in:1,2',
        'agendaItems.*.duration_label' => 'required|string|max:100',
        'agendaItems.*.subtitle' => 'nullable|string|max:255',
        'agendaItems.*.description' => 'nullable|string',

        'topics.*.topic_text' => 'required|string|max:255',
        'topics.*.session_number' => 'required|integer|in:1,2',

        'audiencePoints.*.text' => 'required|string|max:255',
    ];

    public function mount($event = null)
    {
        $this->phases = Phase::orderBy('order', 'asc')->get();
        $this->allSpeakers = Speaker::orderBy('name', 'asc')->get();

        if ($event) {
            $this->event = $event;
            $this->isEdit = true;

            // Load model attributes
            $this->phase_id = $event->phase_id;
            $this->title = $event->title;
            $this->tagline = $event->tagline;
            $this->description = $event->description;
            $this->date = $event->date ? $event->date->format('Y-m-d') : null;
            $this->location = $event->location;
            $this->ticket_url = $event->ticket_url;
            $this->status = $event->status->value;
            $this->meta_title = $event->meta_title;
            $this->meta_description = $event->meta_description;

            // Load associated speakers
            $this->selectedSpeakers = $event->speakers->pluck('id')->toArray();

            // Load sessions
            foreach ($event->sessions as $session) {
                $this->sessions[] = [
                    'id' => $session->id,
                    'session_number' => $session->session_number,
                    'title' => $session->title,
                    'description' => $session->description,
                    'start_time' => $session->start_time,
                    'end_time' => $session->end_time,
                ];
            }

            // Load agenda items
            foreach ($event->agendaItems as $item) {
                $this->agendaItems[] = [
                    'session_group' => $item->session_group,
                    'title' => $item->title,
                    'subtitle' => $item->subtitle,
                    'description' => $item->description,
                    'duration_label' => $item->duration_label,
                ];
            }

            // Load topics
            foreach ($event->sessions as $session) {
                foreach ($session->topics as $topic) {
                    $this->topics[] = [
                        'session_number' => $session->session_number,
                        'topic_text' => $topic->topic_text,
                    ];
                }
            }

            // Load audience points
            foreach ($event->audiencePoints as $point) {
                $this->audiencePoints[] = [
                    'text' => $point->text,
                ];
            }
        } else {
            // Seed defaults for empty form
            $this->addSession(1);
            $this->addSession(2);
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // Repeaters actions
    public function addSession($num = null)
    {
        $sessionNumber = $num ?? (count($this->sessions) + 1);
        $this->sessions[] = [
            'id' => null,
            'session_number' => $sessionNumber,
            'title' => '',
            'description' => '',
            'start_time' => '09:00',
            'end_time' => '11:30',
        ];
    }

    public function removeSession($index)
    {
        unset($this->sessions[$index]);
        $this->sessions = array_values($this->sessions);
    }

    public function addAgendaItem($group = 1)
    {
        $this->agendaItems[] = [
            'session_group' => $group,
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'duration_label' => '09.00 - 10.00',
        ];
    }

    public function removeAgendaItem($index)
    {
        unset($this->agendaItems[$index]);
        $this->agendaItems = array_values($this->agendaItems);
    }

    public function addTopic($group = 1)
    {
        $this->topics[] = [
            'session_number' => $group,
            'topic_text' => '',
        ];
    }

    public function removeTopic($index)
    {
        unset($this->topics[$index]);
        $this->topics = array_values($this->topics);
    }

    public function addAudiencePoint()
    {
        $this->audiencePoints[] = [
            'text' => '',
        ];
    }

    public function removeAudiencePoint($index)
    {
        unset($this->audiencePoints[$index]);
        $this->audiencePoints = array_values($this->audiencePoints);
    }

    /**
     * Save the event.
     */
    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Generate slug
            $slug = Str::slug($this->title);
            $originalSlug = $slug;
            $count = 1;
            $excludeId = $this->event->id ?? 0;
            while (Event::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $eventData = [
                'phase_id' => $this->phase_id,
                'title' => $this->title,
                'tagline' => $this->tagline,
                'description' => $this->description,
                'date' => $this->date,
                'location' => $this->location,
                'ticket_url' => $this->ticket_url,
                'status' => $this->status,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'slug' => $slug,
            ];

            // 2. Create or Update Event
            if ($this->isEdit) {
                $this->event->update($eventData);
                $event = $this->event;
                
                // Clear old sub-records to re-insert cleanly
                $event->sessions()->delete();
                $event->agendaItems()->delete();
                $event->audiencePoints()->delete();

                activity()
                    ->performedOn($event)
                    ->log('mengubah detail event');
            } else {
                $event = Event::create($eventData);

                activity()
                    ->performedOn($event)
                    ->log('membuat event baru');
            }

            // 3. Attach Speakers
            $event->speakers()->sync($this->selectedSpeakers);

            // 4. Save Sessions & Session Topics
            foreach ($this->sessions as $sData) {
                $session = EventSession::create([
                    'event_id' => $event->id,
                    'session_number' => $sData['session_number'],
                    'title' => $sData['title'],
                    'description' => $sData['description'],
                    'start_time' => $sData['start_time'],
                    'end_time' => $sData['end_time'],
                ]);

                // Save matching topics for this session
                $sessionOrder = 1;
                foreach ($this->topics as $tData) {
                    if ((int)$tData['session_number'] === (int)$sData['session_number']) {
                        EventTopic::create([
                            'event_session_id' => $session->id,
                            'order' => $sessionOrder++,
                            'topic_text' => $tData['topic_text'],
                        ]);
                    }
                }
            }

            // 5. Save Rundown Agenda Items
            $agendaOrder = 1;
            foreach ($this->agendaItems as $aData) {
                EventAgendaItem::create([
                    'event_id' => $event->id,
                    'session_group' => $aData['session_group'],
                    'order' => $agendaOrder++,
                    'title' => $aData['title'],
                    'subtitle' => $aData['subtitle'],
                    'description' => $aData['description'],
                    'duration_label' => $aData['duration_label'],
                ]);
            }

            // 6. Save Target Audience Points
            $audienceOrder = 1;
            foreach ($this->audiencePoints as $apData) {
                EventAudiencePoint::create([
                    'event_id' => $event->id,
                    'order' => $audienceOrder++,
                    'text' => $apData['text'],
                ]);
            }
        });

        session()->flash('success', 'Event berhasil disimpan.');
        return redirect()->route('admin.events.index');
    }

    public function render()
    {
        return view('livewire.admin.event-form');
    }
}
