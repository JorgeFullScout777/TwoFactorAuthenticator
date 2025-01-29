<button class="g-recaptcha" 
        data-sitekey="6LczjsYqAAAAAIp_JT8ls6rdZixKUZ_vX3pNcg0n" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button>

<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
      document.getElementById("register-form").submit();
    }
  </script>