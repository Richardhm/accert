<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
    <style>
        * {
            margin:0;padding:0;box-sizing: border-box;list-style: none;
        }
        body {
            min-height:100vh;
            background:url({{asset('space.jpg')}});
            background-position:center;
            background-size:cover;
            overflow:hidden;
        }
        .navbar {
            position:relative;
            background:rgba(254,254,254,0.18);
            padding:20px;
            width:270px;
            top:50px;
            left:20px;
            backdrop-filter: blur(15px);
            border:2px solid rgba(254,254,254,0.5);
            border-radius:15px;
        }
        .profile {
            position:relative;
            display:flex;
            width:100%;
            height:100%;
            justify-content:space-between;
            align-items:center;
            padding: 20px 0;
        }

        .profile::after {
            position:absolute;
            content:'';
            width:100%;
            height:2px;
            background:#fff;
            opacity:0.5;
            left:0;
            bottom: -20px;
        }
        .profile .imgbox {
            position:relative;
            height:80px;
            width:80px;
            border:2px solid #fff;
            border-radius:50%;
            overflow: hidden;
        }
        .imgbox img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .heading {
            color:#fff;
        }
        .heading h3 {
            font-size:1.15em;
            font-weight:500;

        }

        .heading h4{
            opacity:0.5;
            font-size:1em;
            font-weight:400;
        }

        ul {
            margin-top:40px;
        }
        ul li {
            list-style: none;
        }
        ul li a {
            color:#fff;
            font-size:1.2em;
            font-weight:400;
            display:block;
            padding:0 30px;
            height:60px;
            line-height:60px;
            text-decoration:none;
            text-transform: capitalize;
            border-radius:8px;
            transition: .4s .05s ease-out;
        }
        ul li:hover a {
            color:#333;
            background:#FFF;
            transition: 0s ease-out;
        }
        ul li a i {
            scale: 1.3;
            display: inline-block;
            margin-right: 20px;
        }

        @media screen and (max-width: 768px) {
            .navbar {
                width:90px;
                padding:10px;
                transition: 0.3s 0s ease-out;
            }
            .profile {
                display: grid;
                place-content: center;
                padding-bottom: 20px;
                scale: .8;
            }
            .heading {
                display:none;
            }
            ul li a {
                text-align: center;
                padding:0;
            }
            ul li a span {
                display:none;
            }
            ul li a i {
                margin:0;
            }
            ul li {
                position:relative;
            }
            ul li::before {
                position:absolute;
                content:attr(text-data);
                padding: 8px 12px;
                background:#fff;
                color:#333;
                font-weight:500;
                top: 50%;
                left:100px;
                transform: translateX(100px) translateY(-50%);
                border-radius:8px;
                text-transform:capitalize;
                opacity: 0;
                visibility: hidden;
            }
            ul li::after {
                position:absolute;
                content:'';
                border:10px solid #fff;
                border-bottom-color:transparent;
                border-top-color:transparent;
                border-left-color:transparent;
                left:82px;
                top:50%;
                transform: translateX(100px) translateY(-50%);
                opacity: 0;
                visibility: hidden;
            }
            ul li:hover::before,
            ul li:hover::after {
                transform: translateX(0px) translateY(-50%);
                opacity: 1;
                visibility: visible;
                transition: 0.15s ease-out;
            }


        }
    </style>
    <title>Raking</title>
</head>
<body>
    <div class="navbar">
        <div class="profile">
            <div class="imgbox">
                <img src="{{asset('colaboradores/1675254733_avatar-s-3.jpg')}}" alt="User">
            </div>
            <div class="heading">
                <h3 class="title">WebKit Coding</h3>
                <h4 class="label">Developer</h4>
            </div>
        </div>

        <ul>
            <li text-data="dashboard">
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span>dashboard</span>
                </a>
            </li>
            <li text-data="trending">
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span>trending</span>
                </a>
            </li>
            <li text-data="notifications">
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span>notifications</span>
                </a>
            </li>
            <li text-data="portfolio">
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span>notifications</span>
                </a>
            </li>
            <li text-data="portfolio">
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span>portfolio</span>
                </a>
            </li>
            <li text-data="contact">
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span>contact</span>
                </a>
            </li>
            <li text-data="location">
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span>location</span>
                </a>
            </li>


        </ul>





    </div>
</body>
</html>
