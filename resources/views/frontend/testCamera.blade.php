<script>
  if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
    alert("Your device supported")
  } else {
    alert("Your device not supported1")
  }
</script>