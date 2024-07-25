<!--footer-->
<div id="footer">
        <div class="main-widgets">
            <div class="widget-1">
                <h3>About <?= $settings['title'] ?></h3>
                <p><?= $settings['description'] ?></p>
            </div>
            <div class="widget-2">
                <h3>Quick-links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>
            <div class="widget-3" id="contact">
                <h3>Send a Request to Admin</h3>
                <?php include "./admin/adminHelpers/formErrors.php"; ?>
                <form action="index.php" method="post">                    
                    <textarea rows="4" name="message" placeholder="Your Message..." required></textarea>
                    <button type="submit" name="send" class="btn">Send</button>
                </form>
            </div>
        </div>
        <div class="copyright">
            <small class="text-muted">Developed by</small>
            <a href="#">Favour Dalamu</a>
        </div>
    </div>
    
    <script src="./js/main.js"></script>
    <script src="./js/theme-toggler.js"></script>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>