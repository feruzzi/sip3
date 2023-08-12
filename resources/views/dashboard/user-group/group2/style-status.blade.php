<span
    class="font-extrabold @if ($group2->group2_status == 1) badge bg-light-success @elseif($group2->group2_status == -1) badge bg-light-danger @else badge bg-light-warning @endif">
    @if ($group2->group2_status == 1)
        Aktif
    @elseif($group2->group2_status == -1)
        Administator
    @else
        Tidak Aktif
    @endif
</span>
