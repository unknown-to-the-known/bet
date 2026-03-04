</main>
<script type="text/javascript">
  var load = document.getElementById("loading");
  function loadfun()
  {
    load.style.display = 'none';
  }
</script>

<!-- Modal -->
<div class="modal fade" id="exampleModal_year" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel" style="font-family: 'Nunito Sans'">Select Academic year</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <a href="<?php echo BASE_URL; ?>pages/session_setter?id=2023_24">
          <button class="btn btn-success-soft btn-sm"><i class="fas fa-graduation-cap"></i> Year 2023-24</button>
        </a>
        <a href="<?php echo BASE_URL; ?>pages/session_setter?id=2024_25">
          <button class="btn btn-success-soft btn-sm"><i class="fas fa-graduation-cap"></i> Year 2024-25</button>
        </a>

        <a href="<?php echo BASE_URL; ?>pages/session_setter?id=2025_26">
          <button class="btn btn-success-soft btn-sm"><i class="fas fa-graduation-cap"></i> Year 2025-26</button>
        </a>
		  
		  <a href="<?php echo BASE_URL; ?>pages/session_setter?id=2026_27">
          <button class="btn btn-success-soft btn-sm"><i class="fas fa-graduation-cap"></i> Year 2026-27</button>
        </a>
		  
		  <a href="<?php echo BASE_URL; ?>pages/session_setter?id=2027_28">
          <button class="btn btn-success-soft btn-sm"><i class="fas fa-graduation-cap"></i> Year 2027-28</button>
        </a>
      </div>
    </div>
  </div>
<!-- Back to top -->
<div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>
<!-- Bootstrap JS -->
<script src="<?php echo BASE_URL; ?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- Vendors -->
<script src="<?php echo BASE_URL; ?>assets/vendor/glightbox/js/glightbox.js"></script>
<script src="<?php echo BASE_URL; ?>assets/vendor/choices/js/choices.min.js"></script>
</body>
</html>

