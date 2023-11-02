<h2>Đả Đảo Công Ty</h2>
<form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="excel_file">
    <button type="submit">Kiểm Tra</button>
</form>
