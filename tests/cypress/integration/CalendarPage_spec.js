describe('staff navlink', () => {

    //add
    
    it('checks if the admin can view all tasks Inventory', () => {
        // cy.refreshDatabase();
        //change phone number so that it can not display phone number already in use
        cy.visit('/login');
        cy.get('#phone-number').type('0916665210');
        cy.get('#password').type('1234');
        cy.contains('button','Login').click();
        cy.assertRedirect('/dashboard');
        cy.get(':nth-child(5) > a > .flex').click()
       
        // cy.get('#full-name').type('staff to be deleted');
        // cy.get('#phone-number').type('0911223344');
        // cy.get('#role').select('staff');
        // cy.get('.btn-primary').click();
    });
    //edit
    it.only('checks if the staff can view their tasks', () => {
        // cy.refreshDatabase();
        //change phone number so that it can not display phone number already in use
        cy.visit('/login');
        cy.get('#phone-number').type('0916665210');
        cy.get('#password').type('1234');
        cy.contains('button','Login').click();
        cy.assertRedirect('/dashboard');
        cy.get(':nth-child(5) > a > .flex').click()
        cy.calendarChecker()
        // cy.get('#full-name').type('staff to be deleted');
        // cy.get('#phone-number').type('0911223344');
        // cy.get('#role').select('staff');
        // cy.get('.btn-primary').click();
    });

    
    });
    