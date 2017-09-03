
		<script type="text/javascript" src="/public/js/jquery-3.2.1.min.js"></script>


		<!-- Main -->
		<?php if ($_SERVER['REQUEST_URI'] == '/login'): ?>
			<script type="text/javascript" src="/public/js/login.js"></script>
		<?php else: ?>
			<!-- Calendar -->
			<script type="text/javascript" src="/public/plugins/datetimepicker/jquery.js"></script>
			<script src="/public/plugins/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

			<script type="text/javascript" src="/public/js/app.js"></script>
			<script type="text/javascript" src="/public/js/app2.js"></script>
			<script type="text/javascript" src="/public/js/socket.js"></script>

			<!-- Select 2 -->
			<script type="text/javascript" src="/public/plugins/select2/dist/js/select2.min.js"></script>
	        <script type="text/javascript">
	          $(".js-example-basic-multiple").select2({
				  placeholder: "Выберите группу",
				  allowClear: true
			  });
	        </script>
		<?php endif; ?>

	</body>
</html>