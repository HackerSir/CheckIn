<span style="font-size: 2em">
    {{ link_to_route('user.show', $name, $id) }}
    @foreach($roles as $role)
        <span class="badge badge-secondary">{{ $role['display_name'] }}</span>
    @endforeach
</span>
