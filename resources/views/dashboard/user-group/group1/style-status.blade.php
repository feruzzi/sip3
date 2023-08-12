<span
    class="font-extrabold @if ($group1->group1_status == 1) badge bg-light-success @elseif($group1->group1_status == -1) badge bg-light-danger @else badge bg-light-warning @endif">
    @if ($group1->group1_status == 1)
        Aktif
    @elseif($group1->group1_status == -1)
        Administator
    @else
        Tidak Aktif
    @endif
</span>
