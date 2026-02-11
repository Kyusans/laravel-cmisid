@props(['table_data'])

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                @foreach ($table_data['columns'] as $column)
                    <th scope="col">{{ $column }}</th>
                @endforeach
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table_data['rows'] as $row)
                <tr>
                    @foreach ($row as $item)
                        <td>{{ $item }}</td>
                    @endforeach
                    <td>
                        <button type="button" class="btn btn-primary">view more</button>
                        <button type="button" class="btn btn-danger">delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>