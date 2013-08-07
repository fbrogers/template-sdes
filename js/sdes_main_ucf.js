$(function(){ 
    if(self != top){
        top.location = self.location;
    }

    $("a.external").click(function(e){
        window.open(this.href);
        e.preventDefault();
    });

    $(".nav-menu-button").click(function(e){
        $("#nav-under").slideToggle();
        e.preventDefault();
    });
});