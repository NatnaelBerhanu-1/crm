Cypress.on('uncaught:exception', (err, runnable) => {
    return false;
  });

describe('change password as staff', () => {
    it('the users should be able to change their password', () => {
        //create a custom function that changes password if the authentication fails
        // cy.refreshDatabase();
        cy.visit('/login');
        cy.get('#phone-number').type('0909090909');
        cy.get('#password').type('2345');
        cy.contains('button','Login').click();
        cy.contains('Settings').click();
        cy.get('#old-password').type('2345')
        cy.get('#new-password').type('1234')
        cy.get('#confirm-password').type('1234')
        cy.get('.btn-primary').click()
        //assert here
        cy.contains('Password changed successfully');


    });


    //change password as admin

// describe('change password as admin', () => {
    //     it('the users should be able to change their password', () => {
    //         //create a custom function that changes password if the authentication fails
    //         // cy.refreshDatabase();
    //         cy.visit('/login');
    //         cy.get('#phone-number').type('0909090909');
    //         cy.get('#password').type('2345');
    //         cy.contains('button','Login').click();
    //         cy.contains('Settings').click();
    //         cy.get('#old-password').type('2345')
    //         cy.get('#new-password').type('1234')
    //         cy.get('#confirm-password').type('1234')
    //         cy.get('.btn-primary').click()
    //         //assert here
    //         cy.contains('Password changed successfully');


    //     });

});


//second


