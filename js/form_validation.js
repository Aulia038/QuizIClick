// js/form-validation.js

function validatePassword(password) {
    // Minimal 8 karakter, kombinasi huruf dan angka
    var regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    return regex.test(password);
}

function validatePhoneNumber(phone) {
    var cleaned = phone.replace(/[^0-9]/g, '');
    return cleaned.length >= 10;
}

function checkPasswordStrength(passwordField, strengthFieldId) {
    var password = passwordField.value;
    var strengthField = document.getElementById(strengthFieldId);
    
    if (password.length === 0) {
        strengthField.innerHTML = '';
        return;
    }
    
    var strength = 0;
    var feedback = '';
    
    if (password.length >= 8) strength++;
    if (/[A-Za-z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    
    switch(strength) {
        case 3:
            feedback = '<span style="color:#27ae60"><i class="glyphicon glyphicon-ok"></i> Password kuat</span>';
            break;
        case 2:
            feedback = '<span style="color:#f39c12"><i class="glyphicon glyphicon-info-sign"></i> Password cukup</span>';
            break;
        case 1:
            feedback = '<span style="color:#e74c3c"><i class="glyphicon glyphicon-warning-sign"></i> Password lemah</span>';
            break;
        default:
            feedback = '<span style="color:#e74c3c"><i class="glyphicon glyphicon-remove"></i> Password terlalu pendek</span>';
    }
    
    strengthField.innerHTML = feedback;
}

function checkPhoneFormat(phoneField) {
    var phone = phoneField.value;
    var formatField = document.getElementById('phoneFormatGuru');
    
    if (phone.length === 0) {
        formatField.innerHTML = '';
        return;
    }
    
    var cleaned = phone.replace(/[^0-9]/g, '');
    
    if (cleaned.length < 10) {
        formatField.innerHTML = '<span style="color:#e74c3c"><i class="glyphicon glyphicon-warning-sign"></i> Minimal 10 digit angka</span>';
    } else {
        formatField.innerHTML = '<span style="color:#27ae60"><i class="glyphicon glyphicon-ok"></i> Format nomor OK</span>';
    }
}

function validateFormSiswa() {
    var y = document.forms["formSiswa"]["name"].value;	
    if (y == null || y == "") {
        alert("Nama harus diisi.");
        return false;
    }
    var z = document.forms["formSiswa"]["college"].value;
    if (z == null || z == "") {
        alert("Nama lembaga harus diisi.");
        return false;
    }
    var x = document.forms["formSiswa"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Alamat email tidak valid.");
        return false;
    }
    var a = document.forms["formSiswa"]["password"].value;
    if(a == null || a == ""){
        alert("Password harus diisi");
        return false;
    }
    if(!validatePassword(a)){
        alert("Password harus minimal 8 karakter dan kombinasi huruf dan angka.");
        return false;
    }
    var b = document.forms["formSiswa"]["cpassword"].value;
    if (a!=b){
        alert("Password dan konfirmasi password tidak cocok.");
        return false;
    }
    return true;
}

function validateFormGuru() {
    var namaGuru = document.forms["formGuru"]["nama_guru"].value;	
    if (namaGuru == null || namaGuru == "") {
        alert("Nama guru harus diisi.");
        return false;
    }
    
    var pendidikan = document.forms["formGuru"]["pendidikan_terakhir"].value;
    if (pendidikan == null || pendidikan == "") {
        alert("Pendidikan terakhir harus diisi.");
        return false;
    }
    
    var mapel = document.forms["formGuru"]["mapel"].value;
    if (mapel == null || mapel == "") {
        alert("Mata pelajaran harus diisi.");
        return false;
    }
    
    var mob = document.forms["formGuru"]["mob_guru"].value;
    if (mob == null || mob == "") {
        alert("Nomor HP harus diisi.");
        return false;
    }
    if (!validatePhoneNumber(mob)) {
        alert("Nomor HP harus angka, minimal 10 digit.");
        return false;
    }
    
    var email = document.forms["formGuru"]["email_guru"].value;
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
        alert("Alamat email tidak valid.");
        return false;
    }
    
    var password = document.forms["formGuru"]["password_guru"].value;
    if(password == null || password == ""){
        alert("Password harus diisi");
        return false;
    }
    if(!validatePassword(password)){
        alert("Password harus minimal 8 karakter dan kombinasi huruf dan angka.");
        return false;
    }
    
    var confirmPassword = document.forms["formGuru"]["cpassword_guru"].value;
    if (password != confirmPassword){
        alert("Password dan konfirmasi password tidak cocok.");
        return false;
    }
    return true;
}

function showForm(type) {
    document.getElementById('formSiswa').style.display = (type === 'siswa') ? 'block' : 'none';
    document.getElementById('formGuru').style.display = (type === 'guru') ? 'block' : 'none';
    
    // tombol aktif
    document.getElementById('btnSiswa').classList.toggle('btn-dark', type === 'siswa');
    document.getElementById('btnSiswa').classList.toggle('btn-secondary', type !== 'siswa');
    document.getElementById('btnGuru').classList.toggle('btn-dark', type === 'guru');
    document.getElementById('btnGuru').classList.toggle('btn-secondary', type !== 'guru');
}

// Set default form saat page load
window.onload = function() {
    showForm('siswa'); // Default tampilkan form siswa
};