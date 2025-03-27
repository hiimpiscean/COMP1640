@extends('masters.uiMaster')
@section('main')
  <div class="blog-header" data-aos="fade-down">
    <h1>Blog Lecturers & Courses</h1>
  </div>
  <div class="container-blog">
    <section class="section" data-aos="fade-right">
      <h2>Lecturers</h2>
      <div class="lecturer" data-aos="flip-left">
        <h3>Dr. Nguyen Van A</h3>
        <p><strong>Specialization:</strong> Artificial Intelligence</p>
        <p><strong>Experience:</strong> 10 years of teaching and research</p>
      </div>
      <div class="lecturer" data-aos="flip-left">
        <h3>MSc. Tran Thi B</h3>
        <p><strong>Specialization:</strong> Data Science</p>
        <p><strong>Experience:</strong> 7 years of teaching</p>
      </div>
    </section>
    <section class="section" data-aos="fade-right">
      <h2>Courses</h2>
      <div class="course" data-aos="flip-left">
        <h3>Basic Python Programming</h3>
        <p><strong>Duration:</strong> 10 weeks</p>
        <p><strong>Description:</strong> Master basic programming concepts with Python.</p>
      </div>
      <div class="course" data-aos="flip-left">
        <h3>Applied Machine Learning</h3>
        <p><strong>Duration:</strong> 12 weeks</p>
        <p><strong>Description:</strong> Learn Machine Learning algorithms and their real-world applications.</p>
      </div>
    </section>
  </div>
@endsection

<style>
  .blog-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    text-align: center;
    padding: 30px 20px;
    font-size: 28px;
    font-weight: bold;
    border-radius: 10px;
    margin-bottom: 20px;
  }
  .container-blog {
    width: 80%;
    margin: auto;
    overflow: hidden;
    padding: 25px;
    background: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
  }
  .section {
    margin-bottom: 30px;
    padding: 20px;
  }
  h2 {
    color: #333;
    border-bottom: 3px solid #764ba2;
    padding-bottom: 8px;
    font-size: 22px;
  }
  .lecturer, .course {
    border: 2px solid #ddd;
    padding: 18px;
    margin-bottom: 15px;
    border-radius: 10px;
    background: #f9f9f9;
    transition: all 0.3s ease-in-out;
  }
  .lecturer:hover, .course:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    background: #fff;
  }
</style>
@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 1200,
      once: true,
    });
  </script>
@endsection
