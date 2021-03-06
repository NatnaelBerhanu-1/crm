var isAuthenticated = function() {
    if (localStorage.getItem("user")!=null) {
        return true;
    }else{
        return false;
    }
}

var isAdmin = function() {
    if (JSON.parse(localStorage.getItem('user')).role == 'admin'){
        return true;
    }else{
        return false;
    }
}

var isStaff = function() {
    if (JSON.parse(localStorage.getItem('user')).role == 'staff'){
        return true;
    }else{
        return false;
    }
}

var user = function() {
    return JSON.parse(localStorage.getItem('user'));
}

export default{
    isAuthenticated,
    isAdmin,
    isStaff,
    user
}
