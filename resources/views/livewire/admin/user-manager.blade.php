<div>
    <!-- Page Actions Header -->
    <div class="mb-6 flex justify-between items-center">
        <p class="text-caption text-brand-ink/60">Kelola daftar akun administrator dan hak akses role.</p>
        <button 
            @click="$dispatch('open-modal', 'user-modal')" 
            wire:click="resetFields"
            type="button" 
            class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-accent/50"
            id="btn-add-user"
        >
            + Tambah User
        </button>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Users list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4 w-20 text-center">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 w-36 text-center">Role</th>
                        <th class="px-6 py-4 w-48 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center font-bold text-brand-primary">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-primary flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                    {{ substr($u->name, 0, 1) }}
                                </div>
                                {{ $u->name }}
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65">
                                {{ $u->email }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($u->role === 'super-admin')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-brand-blush-lt/20 text-brand-secondary border-brand-blush-lt/30">Super Admin</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-emerald-50 text-emerald-700 border-emerald-200">Editor</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button 
                                    wire:click="edit({{ $u->id }})" 
                                    type="button" 
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold text-brand-primary border border-brand-primary/10 hover:bg-brand-primary/5 transition-all"
                                >
                                    Ubah
                                </button>
                                @if($u->id !== auth()->id())
                                    <button 
                                        wire:click="confirmDelete({{ $u->id }})" 
                                        type="button" 
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold text-red-600 border border-red-100 hover:bg-red-50 transition-all"
                                    >
                                        Hapus
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-caption text-brand-ink/50">
                                Belum ada user admin. Klik + Tambah User untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- User CRUD Modal -->
    <x-ui.modal id="user-modal" :title="$isEdit ? 'Ubah User Admin' : 'Tambah User Baru'">
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="space-y-1.5">
                <label for="form-name" class="text-caption font-semibold text-brand-ink/80 block">Nama Lengkap</label>
                <input 
                    id="form-name"
                    type="text" 
                    wire:model="name" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="Contoh: Ahmad Fauzi"
                />
                @error('name') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1.5">
                <label for="form-email" class="text-caption font-semibold text-brand-ink/80 block">Alamat Email</label>
                <input 
                    id="form-email"
                    type="email" 
                    wire:model="email" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="fauzi@taqwamovement.id"
                />
                @error('email') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1.5">
                <label for="form-password" class="text-caption font-semibold text-brand-ink/80 block">
                    Password {{ $isEdit ? '(Kosongkan jika tidak diubah)' : '' }}
                </label>
                <input 
                    id="form-password"
                    type="password" 
                    wire:model="password" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="Minimal 8 karakter"
                />
                @error('password') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1.5">
                <label for="form-role" class="text-caption font-semibold text-brand-ink/80 block">Role Akses</label>
                <select 
                    id="form-role"
                    wire:model="role" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                >
                    <option value="editor">Editor</option>
                    <option value="super-admin">Super Admin</option>
                </select>
                @error('role') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button 
                    @click="$dispatch('close-modal', 'user-modal')" 
                    type="button" 
                    class="px-5 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-caption font-medium transition-all"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-5 py-2.5 rounded-lg bg-brand-primary hover:bg-brand-secondary text-brand-white text-caption font-semibold transition-all shadow-brand-soft"
                >
                    Simpan
                </button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal id="delete-confirm-modal" title="Konfirmasi Hapus User">
        <div class="space-y-6">
            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus akun user admin ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button 
                    @click="$dispatch('close-modal', 'delete-confirm-modal')" 
                    type="button" 
                    class="px-5 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-caption font-medium transition-all"
                >
                    Batal
                </button>
                <button 
                    wire:click="delete"
                    type="button" 
                    class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-brand-white text-caption font-semibold transition-all shadow-md"
                >
                    Hapus Permanen
                </button>
            </div>
        </div>
    </x-ui.modal>
</div>
