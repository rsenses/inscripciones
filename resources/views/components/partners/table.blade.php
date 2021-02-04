<div class="table">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Logo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($partners as $partner)
                <tr>
                    <td>{{ $partner->name }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" class="img-fuid" style="max-width: 200px;">
                    </td>
                    <td>
                        <a href="{{ route('partners.show', ['partner' => $partner]) }}">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
