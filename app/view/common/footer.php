</div>
<script src="/assets/js/jquery/3.3.1/jquery.min.js"></script>
<script src="/assets/js/bootstrap/4.3.1/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<?php if(!empty($data['scripts'])) { ?>
<?php foreach ($data['scripts'] as $script) { ?>
    <script src="<?php echo $script; ?>"></script>
<?php } ?>
<?php } ?>
</body>
</html>
