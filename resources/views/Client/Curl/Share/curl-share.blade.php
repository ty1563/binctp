<html>
<meta charset="utf-8" />
<title>CURL SHARE</title>

<body>
    <form action="{{ route('curl-share') }}" method="POST">
        @csrf
        <label for="post_id">ID bài viết:</label>
        <input type="text" id="post_id" name="post_id" required>
        <label for="soLuong">Số Lượt Chia Sẽ</label>
        <input type="number" id="soLuong" name="soLuong" required>
        <button type="submit">Chia sẻ</button>
    </form>
</body>
</html>
