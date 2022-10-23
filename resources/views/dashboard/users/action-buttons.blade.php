<a class="btn btn-sm btn-outline-danger delete-user" data-id="{{ $user->username }}"><i
        class="icon dripicons dripicons-trash text-danger"></i></a>
<a class="btn btn-sm btn-outline-warning mx-2 edit-user" data-id="{{ $user->username }}"><i
        class="icon dripicons dripicons-document-edit text-warning"></i></a>
@if ($user->status == 1)
    <a class="btn btn-sm btn-outline-danger set-user" data-id="{{ $user->username }}"><i
            class="icon dripicons dripicons-wrong text-danger"></i></a>
@elseif($user->status == 0)
    <a class="btn btn-sm btn-outline-success set-user" data-id="{{ $user->username }}"><i
            class="icon dripicons dripicons-checkmark text-success"></i></a>
@endif
