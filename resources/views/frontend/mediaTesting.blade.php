<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <div style="display:flex;">
        <p>
            <label for="soundFile">What does your voice sound like?:</label>
            <input type="file" id="soundFile" capture="user" accept="audio/*">
        </p>
        <p>
            <label for="videoFile">Upload a video:</label>
            <input type="file" id="videoFile" capture="environment" accept="video/*">
        </p>
        <p>
            <label for="imageFile">Upload a photo of yourself:</label>
            <input type="file" id="imageFile" capture="user" accept="image/*">
        </p>

    </div>
</body>

</html>