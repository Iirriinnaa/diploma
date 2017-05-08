module.exports = (function(){

    var prod = false,
        livereload = true;

    return {
        setEnv: function(newEnv){
            
            prod = newEnv;
        },
        getEnv: function(){

            return prod;
        },
        setLive: function(){

            livereload = true;
        },
        getLive: function(){

            return livereload;
        }
    };
}());
