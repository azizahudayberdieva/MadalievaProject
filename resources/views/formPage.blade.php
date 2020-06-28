<form action="/store" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="upload" accept="video/*">
    <select name="type">
        <option value="file">File</option>
        <option value="video">Video</option>
    </select>
    <p><input type="submit" /></p>
</form>
