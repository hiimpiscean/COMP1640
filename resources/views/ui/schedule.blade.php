@extends('masters.uiMaster')
@section('main')
  <style>
    body {
      margin: 0;
      padding: 0;
      text-align: center;
    }
    .schedule-container {
      width: 100%;
      max-width: 900px;
      margin: 40px auto;
      background: #ffffff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease-in-out;
      margin-top: 100px;
    }
    .schedule-container:hover {
      transform: translateY(-5px);
    }
    h2 {
      color: #333;
      font-size: 30px;
      margin-bottom: 20px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      background: white;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 15px;
      text-align: center;
      font-size: 16px;
      transition: all 0.3s ease-in-out;
    }
    th {
      background: #007bff;
      color: white;
      text-transform: uppercase;
    }
    tr:nth-child(even) {
      background: #f4f6f9;
    }
    td:hover {
      background: #ffdd57;
      cursor: pointer;
      transform: scale(1.1);
      font-weight: bold;
    }
    .highlight {
      font-weight: bold;
      color: #007bff;
      text-transform: uppercase;
    }
  </style>
  <div class="schedule-container" data-aos="fade-up">
    <h2>School Schedule</h2>
    <table>
      <tr>
        <th>Thứ</th>
        <th>Tiết 1</th>
        <th>Tiết 2</th>
        <th>Tiết 3</th>
        <th>Tiết 4</th>
        <th>Tiết 5</th>
      </tr>
      <tr>
        <td class="highlight">Thứ 2</td>
        <td>Adobe Premiere Pro for Beginners</td>
        <td>Adobe Premiere Pro for Beginners</td>
        <td> </td>
        <td> </td>
        <td>SEO & Google Ads Mastery</td>
      </tr>
      <tr>
        <td class="highlight">Thứ 3</td>
        <td>JavaScript for Web Designers</td>
        <td>JavaScript for Web Designers</td>
        <td>Web Design & Development Course for Beginners</td>
        <td>Social Media Marketing Masterclass</td>
        <td> </td>
      </tr>
      <tr>
        <td class="highlight">Thứ 4</td>
        <td> </td>
        <td> </td>
        <td>Social Media Marketing Masterclass</td>
        <td>JavaScript for Web Designers</td>
        <td>JavaScript for Web Designers</td>
      </tr>
      <tr>
        <td class="highlight">Thứ 5</td>
        <td>Adobe Photoshop Essentials</td>
        <td>After Effects Motion Graphics</td>
        <td>After Effects Motion Graphics</td>
        <td> </td>
        <td> </td>
      </tr>
      <tr>
        <td class="highlight">Thứ 6</td>
        <td>Adobe Illustrator Mastery</td>
        <td>Adobe Illustrator Mastery</td>
        <td> </td>
        <td>Social Media Marketing Masterclass</td>
        <td>Social Media Marketing Masterclass</td>
      </tr>
      <tr>
        <td class="highlight">Thứ 7</td>
        <td>Adobe Illustrator Mastery</td>
        <td>Adobe Illustrator Mastery</td>
        <td> </td>
        <td>Social Media Marketing Masterclass</td>
        <td>Social Media Marketing Masterclass</td>
      </tr>
    </table>
  </div>
@endsection
@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
    });
  </script>
@endsection
