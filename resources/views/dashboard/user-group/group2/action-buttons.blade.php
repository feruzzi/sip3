<a class="btn btn-sm btn-outline-danger delete-group2" data-id="{{ $group2->group2_id }}"><i
        class="icon dripicons dripicons-trash text-danger"></i></a>
<a class="btn btn-sm btn-outline-warning mx-2 edit-group2" data-id="{{ $group2->group2_id }}"><i
        class="icon dripicons dripicons-document-edit text-warning"></i></a>
@if ($group2->group2_status == 1)
    <a class="btn btn-sm btn-outline-danger set-group2" data-id="{{ $group2->group2_id }}"><i
            class="icon dripicons dripicons-wrong text-danger"></i></a>
@elseif($group2->group2_status == 0)
    <a class="btn btn-sm btn-outline-success set-group2" data-id="{{ $group2->group2_id }}"><i
            class="icon dripicons dripicons-checkmark text-success"></i></a>
@endif
