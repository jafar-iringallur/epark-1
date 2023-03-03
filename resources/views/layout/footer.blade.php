<script>
$( document ).ready(function() {
  $("#selMember").select2();
  $("#selBook").select2();
  $("#categorysel").select2();
  $("#batchsel").select2();
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
    var page = $('#page').val();
    if(page == 'Admin Dashboard'){
      
      $("#dashboard").addClass("active");
    }
    else if (page =='Books List' || page =='Add Book' || page == 'Edit Book'|| page == 'Books Categories'){
      $("#books").addClass("active");
    }
    else if(page == 'Members List' || page =='Add Member' || page == 'Edit Member'){
      $("#members").addClass("active");
    }
    else if(page == 'Record'){
      $("#record").addClass("active");
    }
});
</script>
<script src="../js/core/popper.min.js"></script>
  <script src="../js/core/bootstrap.min.js"></script>
  <script src="../js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../js/plugins/chartjs.min.js"></script>
 
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>