@extends('layouts.app')

@section('title', 'Roles Permission')

@section('content')
<div class="row justify-content-center" style="margin: 0; padding-top: 20px;">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-5" style="padding-bottom: 20px; border-bottom: 1px solid #e0e0e0;">
            <h4 style="font-weight: 700; color: #1E3C72; margin: 0; font-size: 1.75rem;">Manajemen Roles & Permissions</h4>
        </div>

        <div class="card" style="
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        ">
            <div class="card-header" style="
                background-color: #fff;
                border-bottom: 2px solid #1E3C72;
                padding: 1.5rem 2rem;
            ">
                <h5 class="card-title" style="
                    color: #1E3C72;
                    font-weight: 700;
                    margin: 0;
                    font-size: 1.5rem;
                ">
                    <i class="fas fa-user-shield me-2" style="color: #3B62A4;"></i> Manajemen Hak Akses
                </h5>
            </div>
            <div class="card-body" style="padding: 2rem;">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="
                        background-color: #d4edda;
                        color: #155724;
                        border-color: #c3e6cb;
                        border-radius: 8px;
                        padding: 1rem;
                        margin-bottom: 1.5rem;
                        border: none;
                    ">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table" style="margin-bottom: 0; border-collapse: separate; border-spacing: 0;">
                        <thead style="background-color: #f1f4f8;">
                            <tr>
                                <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem; width: 15%;">Role</th>
                                <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem; width: 70%;">Permissions</th>
                                <th style="color: #495057; font-weight: 700; vertical-align: middle; border-top: none; padding: 1rem 1.5rem; width: 15%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr class="table-row" style="transition: background-color 0.2s ease;"
                                onmouseover="this.style.backgroundColor='#f9f9f9'"
                                onmouseout="this.style.backgroundColor='transparent'">
                                <td style="vertical-align: middle; padding: 1rem 1.5rem;">
                                    <div class="d-flex align-items-center">
                                        <span class="badge" style="
                                            background-color: #1E3C72;
                                            color: white;
                                            font-weight: 600;
                                            padding: 0.6em 1em;
                                            border-radius: 4px;
                                            font-size: 0.9rem;
                                        ">{{ $role->name }}</span>
                                    </div>
                                </td>
                                <td style="vertical-align: middle; padding: 1rem 1.5rem;">
                                    <form method="POST" action="{{ route('roles-permission.update', $role->id) }}" class="permission-form" style="
                                        background: #f8f9fa;
                                        padding: 1.5rem;
                                        border-radius: 8px;
                                        border: 1px solid #e9ecef;
                                    ">
                                        @csrf
                                        @method('PUT')

                                        <!-- Permission Groups -->
                                        <div class="permission-groups">
                                            @php
                                                // Group permissions by module
                                                $groupedPermissions = [];
                                                foreach($permissions as $permission) {
                                                    $parts = explode(' ', $permission->name);
                                                    $module = count($parts) > 1 ? $parts[1] : 'other';
                                                    $groupedPermissions[$module][] = $permission;
                                                }
                                            @endphp

                                            @foreach($groupedPermissions as $module => $modulePermissions)
                                            <div class="permission-group mb-4" style="
                                                border-left: 3px solid #1E3C72;
                                                padding-left: 1rem;
                                            ">
                                                <h6 style="
                                                    color: #1E3C72;
                                                    font-weight: 600;
                                                    margin-bottom: 0.75rem;
                                                    font-size: 0.9rem;
                                                    text-transform: uppercase;
                                                ">
                                                    <i class="fas fa-folder me-1"></i>
                                                    {{ ucfirst($module) }}
                                                </h6>
                                                <div class="row">
                                                    @foreach($modulePermissions as $permission)
                                                    <div class="col-lg-4 col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-checkbox"
                                                                   type="checkbox"
                                                                   name="permissions[]"
                                                                   value="{{ $permission->id }}"
                                                                   id="perm_{{ $role->id }}_{{ $permission->id }}"
                                                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                                   style="
                                                                       border-radius: 4px;
                                                                       border: 1px solid #ced4da;
                                                                   "
                                                                   onchange="this.style.backgroundColor=this.checked?'#1E3C72':'#fff'">
                                                            <label class="form-check-label" for="perm_{{ $role->id }}_{{ $permission->id }}" style="
                                                                font-size: 0.875rem;
                                                                color: #495057;
                                                                font-weight: 500;
                                                            ">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @if(!$loop->last)
                                                <hr style="margin: 1rem 0; color: #e9ecef;">
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>

                                        <!-- Quick Actions -->
                                        <div class="quick-actions mb-3" style="
                                            padding: 1rem;
                                            background: white;
                                            border-radius: 6px;
                                            border: 1px solid #dee2e6;
                                        ">
                                            <small style="color: #6c757d; font-weight: 600; margin-right: 1rem;">Quick Actions:</small>
                                            <button type="button" class="btn btn-sm select-all" data-role="{{ $role->id }}" style="
                                                background-color: #3B62A4;
                                                border-color: #3B62A4;
                                                color: white;
                                                border-radius: 6px;
                                                font-weight: 500;
                                                padding: 0.5rem 1rem;
                                                margin-right: 0.5rem;
                                                transition: all 0.2s ease;
                                            "
                                            onmouseover="this.style.backgroundColor='#1E3C72'"
                                            onmouseout="this.style.backgroundColor='#3B62A4'">
                                                <i class="fas fa-check-square me-1"></i>Select All
                                            </button>
                                            <button type="button" class="btn btn-sm deselect-all" data-role="{{ $role->id }}" style="
                                                background-color: #6c757d;
                                                border-color: #6c757d;
                                                color: white;
                                                border-radius: 6px;
                                                font-weight: 500;
                                                padding: 0.5rem 1rem;
                                                transition: all 0.2s ease;
                                            "
                                            onmouseover="this.style.backgroundColor='#5a6268'"
                                            onmouseout="this.style.backgroundColor='#6c757d'">
                                                <i class="fas fa-square me-1"></i>Deselect All
                                            </button>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-sm" style="
                                            background-color: #28a745;
                                            border-color: #28a745;
                                            border-radius: 6px;
                                            font-weight: 500;
                                            padding: 0.6rem 1.2rem;
                                            transition: all 0.2s ease;
                                        "
                                        onmouseover="this.style.backgroundColor='#1e7e34'"
                                        onmouseout="this.style.backgroundColor='#28a745'">
                                            <i class="fas fa-save me-1"></i>Update Permissions
                                        </button>
                                    </form>
                                </td>
                                <td style="vertical-align: middle; white-space: nowrap; padding: 1rem 1.5rem;" class="text-center">
                                    <button type="button" class="btn btn-sm" style="
                                        background-color: #3B62A4;
                                        color: white;
                                        border-radius: 6px;
                                        font-weight: 500;
                                        padding: 0.5rem 0.8rem;
                                        transition: all 0.2s ease;
                                    "
                                    onmouseover="this.style.backgroundColor='#1E3C72'"
                                    onmouseout="this.style.backgroundColor='#3B62A4'"
                                    onclick="showRoleDetails('{{ $role->name }}', {{ $role->permissions }})">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Info Section -->
                <div class="mt-5">
                    <div class="alert alert-info" style="
                        background-color: #e6f7ff;
                        color: #1E3C72;
                        border: 1px solid #1E3C7230;
                        border-radius: 8px;
                        padding: 1.5rem;
                    ">
                        <h6 style="font-weight: 700; margin-bottom: 0.5rem;">
                            <i class="fas fa-info-circle me-2"></i>Informasi
                        </h6>
                        <p style="margin-bottom: 0.5rem; font-size: 0.9rem;">Fitur ini memungkinkan Anda mengatur permissions untuk setiap role. Permissions dikelompokkan berdasarkan modul untuk memudahkan manajemen.</p>
                        <p style="margin-bottom: 0; font-size: 0.9rem;">
                            <strong>Tip:</strong> Gunakan "Select All" atau "Deselect All" untuk mengatur permissions secara cepat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Role Details Modal -->
<div class="modal fade" id="roleDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        ">
            <div class="modal-header" style="
                background-color: #fff;
                border-bottom: 2px solid #1E3C72;
                padding: 1.5rem;
                border-radius: 12px 12px 0 0;
            ">
                <h5 class="modal-title" style="
                    color: #1E3C72;
                    font-weight: 700;
                    margin: 0;
                ">Detail Role: <span id="modalRoleName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <h6 style="
                    color: #1E3C72;
                    font-weight: 600;
                    margin-bottom: 1rem;
                ">Permissions:</h6>
                <div id="modalPermissions" class="d-flex flex-wrap gap-2"></div>
            </div>
            <div class="modal-footer" style="
                background-color: #f8f9fa;
                border-top: 1px solid #e9ecef;
                padding: 1rem 1.5rem;
                border-radius: 0 0 12px 12px;
            ">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="
                    background-color: #6c757d;
                    border-color: #6c757d;
                    border-radius: 6px;
                    font-weight: 500;
                    padding: 0.5rem 1rem;
                ">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Select All functionality
    document.querySelectorAll('.select-all').forEach(button => {
        button.addEventListener('click', function() {
            const roleId = this.getAttribute('data-role');
            const form = this.closest('.permission-form');
            form.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                checkbox.checked = true;
                checkbox.style.backgroundColor = '#1E3C72';
            });
        });
    });

    // Deselect All functionality
    document.querySelectorAll('.deselect-all').forEach(button => {
        button.addEventListener('click', function() {
            const roleId = this.getAttribute('data-role');
            const form = this.closest('.permission-form');
            form.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.style.backgroundColor = '#fff';
            });
        });
    });

    // Form submission confirmation
    document.querySelectorAll('.permission-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const checkedCount = this.querySelectorAll('.permission-checkbox:checked').length;
            if (checkedCount === 0) {
                e.preventDefault();
                if (!confirm('Tidak ada permission yang dipilih. Yakin ingin melanjutkan?')) {
                    return;
                }
            }
        });
    });

    // Initialize checkbox colors
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.style.backgroundColor = checkbox.checked ? '#1E3C72' : '#fff';
    });
});

function showRoleDetails(roleName, permissions) {
    document.getElementById('modalRoleName').textContent = roleName;

    const permissionsContainer = document.getElementById('modalPermissions');
    permissionsContainer.innerHTML = '';

    if (permissions.length === 0) {
        permissionsContainer.innerHTML = '<span class="badge" style="background-color: #ffc107; color: #212529; padding: 0.6em 1em; border-radius: 4px; font-weight: 500;">Tidak ada permissions</span>';
    } else {
        permissions.forEach(permission => {
            const badge = document.createElement('span');
            badge.className = 'badge mb-1';
            badge.style.cssText = 'background-color: #28a745; color: white; padding: 0.6em 1em; border-radius: 4px; font-weight: 500;';
            badge.textContent = permission.name;
            permissionsContainer.appendChild(badge);
        });
    }

    const modal = new bootstrap.Modal(document.getElementById('roleDetailsModal'));
    modal.show();
}
</script>
@endsection