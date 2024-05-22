<script>
var data = JSON.stringify({
  "app_key": "5tunt4masn6pv2hnvte1sb5n3j",
  "app_secret": "1vggbqd4hqk9g96o9rrrp2jftvek578v7d2bnerim12a87dbrrka"
});

var xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function () {
  if (this.readyState === this.DONE) {
    console.log(this.responseText);
  }
});

xhr.open("POST", "https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/token/grant");
xhr.setRequestHeader("username", "sandboxTestUser");
xhr.setRequestHeader("password", "hWD@8vtzw0");

xhr.send(data);
</script>
<?php echo $id_token;?>