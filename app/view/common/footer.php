</div>
<script src="/assets/js/jquery/3.3.1/jquery.min.js"></script>
<script src="/assets/js/bootstrap/4.3.1/bootstrap.bundle.min.js"></script>

<?php if(!empty($data['scripts'])) { ?>
<?php foreach ($data['scripts'] as $script) { ?>
    <script src="<?php echo $script; ?>"></script>
<?php } ?>
<?php } ?>
</body>
</html>
