@if(Session::has('success'))
<script>
Swal.fire({
  title: "Success!",
  text: "{{ session('success') }}",
  icon: "success"
});
</script>
@endif
@if(Session::has('error'))
<script>
Swal.fire({
  title: "Error!",
  text: "{{ session('error') }}",
  icon: "error"
});
</script>
@endif