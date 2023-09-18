@if (session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@elseif(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

<form action="/admin/administrative" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv_file" accept=".csv">
    <button type="submit">Import CSV</button>
</form>
