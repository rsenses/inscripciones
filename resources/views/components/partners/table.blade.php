<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th colspan="2">Logo</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach($partners as $partner)
                <tr>
                    <td style="vertical-align: middle;"> {{ $partner->name }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" class="img-fuid" style="max-width: 200px;">
                    </td>
                    <td  class="text-center" style="vertical-align: middle;">
                        <a class="text-primary " href="{{ route('partners.show', ['partner' => $partner]) }}">
                        <i class="ion ion-ios-eye-outline" aria-hidden="true"></i> Ver
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
