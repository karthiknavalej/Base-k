<html>
<!doctype html>
<title>Mosaique</title>
<style>
* {
  box-sizing: border-box; 
}
body {
  min-height: 100vh;
}
#main {
  display: block;  
}
#container {
        /* border: 1px solid #e5e5e5; */
        margin: 5% 10%;
        border-radius: 2px;
}
#header {
        /* padding: 32px 16px;
        border-bottom: 1px solid #e5e5e5; */
}
#content {
        padding: 32px 16px;
}
#footer {
        /* background-color: #00875F; */
        /* position: relative;
        padding: 16px; */
}

</style>
<body>
  <div id="main">
    <div id="container">
        <div id="header">@yield('header-content', 'NO CONTENT')</div>
        <div id="content">@yield('content', 'NO CONTENT')</div>
        <div id="footer">@yield('footer-content', 'NO CONTENT')</div>
    </div>
  </div>
</body>
</html>