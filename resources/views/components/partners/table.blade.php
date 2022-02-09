<div class="table-responsive">
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
                    <td style="vertical-align: middle;"> {{ $partner->name }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" class="img-fuid" style="max-width: 200px;">
                    </td>
                    <td  class="bg-primary text-center" style="vertical-align: middle;">
                        <a class="text-light " href="{{ route('partners.show', ['partner' => $partner]) }}">
                        <i class="ion ion-ios-eye-outline" aria-hidden="true"></i> Ver
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
