/**
 *  Form validation
 */

(function () {
    'use strict'
    //validate-form is name of class in form tag
    const forms = document.querySelectorAll('.validate-form')
    Array.from(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          
          if (!form.checkValidity()) {
            
            //prevent form submission
            event.preventDefault()
            
            event.stopPropagation()
          }
          // add .was-validated to the form tag
          form.classList.add('was-validated')
          
        }, false)
      })
    })();
