    function popitup(url)
    {
       newwindow=window.open(url,'tickets','height=1000,width=600');
       if (window.focus) {newwindow.focus()}
       return false;
    }