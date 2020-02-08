
    <header>
            <ul>
                <!--<a href="http://localhost/mediasoft/"><li>Home</li></a>-->
                <a href="http://localhost/mediasoft/index.php/product"><li>Products</li></a>
                <a href="http://localhost/mediasoft/index.php/product/saved"><li>MyProducts</li></a>
            </ul>
    </header>

    <style id="header_styles">
        *{
            padding:0;
            margin:0;
        }

        body{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            background:white;
            height:100vh;
        }
    
        header{
            height:50px;
            width:100%;
            padding:10px 25px;
            box-sizing:border-box;
            box-shadow:1px 2px 5px rgba(0,0,0,0.1);
            margin:0 0 5px 0;

            display:flex;
            justify-content:flex-end;
            align-items:center;
        }

        header ul{
            list-style:none;
            
        }

        header ul li{
            display:inline-block;
            color:gray;
            padding:10px;
            box-sizing:border-box;
            border:1px solid transparent;
            border-radius:3px;
        }

        header ul li:hover{
            border:1px solid dodgerblue;
            color:dodgerblue;
        }

    </style>


