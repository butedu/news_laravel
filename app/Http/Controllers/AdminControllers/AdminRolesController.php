<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class AdminRolesController extends Controller
{

    private $rules = ['name' => 'required|unique:roles,name'];
    private array $permissionLabels;
    private array $permissionGroupsConfig;
    private string $fallbackGroupLabel;

    public function __construct()
    {
        $this->permissionLabels = config('permissions.labels', []);
        $this->permissionGroupsConfig = config('permissions.groups', []);
        $this->fallbackGroupLabel = config('permissions.fallback_group_label', 'Chức năng khác');
    }
  
    public function index()
    {
        return view('admin_dashboard.roles.index', [
            'roles' => Role::paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.roles.create', [
            'permissionGroups' => $this->preparePermissionGroups(),
        ]);
    }

 
    public function store(Request $request)
    {


        $validated = $request->validate($this->rules);
        $permissions = $request->input('permissions');


        $role = Role::create($validated);
        $role->permissions()->sync($permissions);

        return redirect()->route('admin.roles.create')->with('success','Thêm quyền mới thành công.');
    }


    public function edit(Role $role)
    {
        return view('admin_dashboard.roles.edit', [
            'role' => $role,
            'permissionGroups' => $this->preparePermissionGroups($role),
        ]);
    }

  
    public function update(Request $request,Role $role)
    {

        $this->rules['name'] = ['required', Rule::unique('roles')->ignore($role)];
        $validated = $request->validate($this->rules);
        $permissions = $request->input('permissions');


        $role->update($validated);
        $role->permissions()->sync($permissions);

        return redirect()->route('admin.roles.edit', $role )->with('success','Cập nhật quyền mới thành công.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success','Xóa quyền thành công.');
    }

    private function preparePermissionGroups(?Role $role = null): Collection
    {
        $permissions = Permission::orderBy('name')->get(['id', 'name']);
        $assignedIds = $role ? $role->permissions->pluck('id')->all() : [];
        $permissionByName = $permissions->keyBy('name');

        $groups = collect($this->permissionGroupsConfig)
            ->map(function (array $group) use ($permissionByName, $assignedIds) {
                $items = collect($group['items'] ?? [])
                    ->map(fn ($permissionName) => $permissionByName->get($permissionName))
                    ->filter()
                    ->map(fn (Permission $permission) => $this->formatPermission($permission, $assignedIds))
                    ->values()
                    ->all();

                if (empty($items)) {
                    return null;
                }

                return [
                    'label' => $group['label'] ?? $this->fallbackGroupLabel,
                    'icon' => $group['icon'] ?? null,
                    'permissions' => $items,
                ];
            })
            ->filter()
            ->values();

        $configuredNames = collect($this->permissionGroupsConfig)
            ->flatMap(fn (array $group) => $group['items'] ?? [])
            ->filter()
            ->unique();

        $fallbackPermissions = $permissions
            ->reject(fn (Permission $permission) => $configuredNames->contains($permission->name))
            ->map(fn (Permission $permission) => $this->formatPermission($permission, $assignedIds))
            ->values()
            ->all();

        if (!empty($fallbackPermissions)) {
            $groups->push([
                'label' => $this->fallbackGroupLabel,
                'icon' => 'bx bx-layer',
                'permissions' => $fallbackPermissions,
            ]);
        }

        return $groups;
    }

    private function formatPermission(Permission $permission, array $assignedIds): array
    {
        return [
            'id' => $permission->id,
            'name' => $permission->name,
            'label' => $this->permissionLabels[$permission->name] ?? $permission->name,
            'checked' => in_array($permission->id, $assignedIds, true),
        ];
    }
}
