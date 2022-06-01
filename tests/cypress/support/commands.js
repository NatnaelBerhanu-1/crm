// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })


// -- This is a parent command --
Cypress.Commands.add('login', (phone, password) => { 

    cy.visit('/login');
        cy.get('#phone-number').type(phone);
        cy.get('#password').type(password);
        cy.contains('button','Login').click();
})


    Cypress.Commands.add('calendarChecker', () => {
        if(cy.contains("Photoshoot") || cy.contains("Photoshoot") || cy.contains("Video shoot") || cy.contains("Documentary") || cy.contains("VIP Request") || cy.contains("Others")){
            assert()
        }
        
    
  })