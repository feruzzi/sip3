<a class="btn btn-sm btn-outline-danger delete-group1" data-id="{{ $group1->group1_id }}"><i
        class="icon dripicons dripicons-trash text-danger"></i></a>
<a class="btn btn-sm btn-outline-warning mx-2 edit-group1" data-id="{{ $group1->group1_id }}"><i
        class="icon dripicons dripicons-document-edit text-warning"></i></a>
@if ($group1->group1_status == 1)
    <a class="btn btn-sm btn-outline-danger set-group1" data-id="{{ $group1->group1_id }}"><i
            class="icon dripicons dripicons-wrong text-danger"></i></a>
@elseif($group1->group1_status == 0)
    <a class="btn btn-sm btn-outline-success set-group1" data-id="{{ $group1->group1_id }}"><i
            class="icon dripicons dripicons-checkmark text-success"></i></a>
@endif
