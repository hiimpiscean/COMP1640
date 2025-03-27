<footer class="footer_section" data-aos="zoom-in" data-aos-delay="300">
  <div class="container">
    <div class="row">
      <div class="col-md-4 footer-col">
        <div class="footer_contact">
          <h4>Contact Us</h4>
          <div class="contact_link_box">
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-map-marker"></i> <span> Hanoi, Vietnam</span>
            </a>
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-phone"></i> <span> Call +84 123456789</span>
            </a>
            <a href="{{route('ui.thank')}}">
              <i class="fa fa-envelope"></i> <span> admin@gmail.com</span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4 footer-col">
        <div class="footer_detail">
          <a href="" class="footer-logo">ATN Company</a>
          <p>The brand is present worldwide and has been growing since 2020.</p>
          <div class="footer_social">
            <a href="{{route('ui.thank')}}"><i class="fa fa-facebook"></i></a>
            <a href="{{route('ui.thank')}}"><i class="fa fa-twitter"></i></a>
            <a href="{{route('ui.thank')}}"><i class="fa fa-linkedin"></i></a>
            <a href="{{route('ui.thank')}}"><i class="fa fa-instagram"></i></a>
            <a href="{{route('ui.thank')}}"><i class="fa fa-pinterest"></i></a>
          </div>
        </div>
      </div>
      <div class="col-md-4 footer-col">
        <h4>Opening Hours</h4>
        <p>Everyday</p>
        <p>6.00 AM - 11.00 PM</p>
      </div>
    </div>
    <div class="footer-info">
      <p>&copy; <span id="displayYear"></span> Copyright belongs to
        <a href="#">ATN Company</a><br><br>
        Distributed By <a href="#" target="_blank">ATN</a>
      </p>
    </div>
  </div>
</footer>
<style>
  .footer_section {
    background: linear-gradient(135deg, #1d1d1d, #343a40);
    color: #fff;
    padding: 50px 0;
  }

  .footer_section h4 {
    font-size: 20px;
    margin-bottom: 20px;
    font-weight: bold;
    color: #f8b400;
  }

  .footer-col {
    text-align: left;
  }

  .footer_contact .contact_link_box a {
    display: block;
    color: #ddd;
    margin-bottom: 10px;
    transition: all 0.3s ease;
  }

  .footer_contact .contact_link_box a:hover {
    color: #f8b400;
    transform: translateX(5px);
  }

  .footer_social a {
    display: inline-block;
    margin: 0 10px;
    color: #ddd;
    font-size: 18px;
    transition: all 0.3s ease;
  }

  .footer_social a:hover {
    color: #f8b400;
    transform: scale(1.2);
  }

  .footer-info {
    text-align: center;
    margin-top: 30px;
    font-size: 14px;
    color: #ccc;
  }

  .footer-info a {
    color: #f8b400;
    font-weight: bold;
    transition: all 0.3s ease;
  }

  .footer-info a:hover {
    color: #ffcd3c;
  }
</style>
