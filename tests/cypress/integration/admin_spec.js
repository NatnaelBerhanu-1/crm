
describe('Admin Page', () => {
    //not on the test plan

        it('checks if the admin page have admin panels', () => {
            // cy.refreshDatabase();
            cy.visit('/login');
            cy.get('#phone-number').type('0916665210');
            cy.get('#password').type('1234');
            cy.contains('button','Login').click();
            cy.assertRedirect('/dashboard');
            cy.contains('Upcomming tasks');
        });

        

    });
