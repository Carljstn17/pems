import './bootstrap';


    // JavaScript to handle dropdown item click
    function setRole(role) {
        document.getElementById('roleDropdown').innerText = role.charAt(0).toUpperCase() + role.slice(1); // Capitalize first letter
        document.getElementById('selectedRole').value = role;
    }