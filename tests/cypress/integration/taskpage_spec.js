describe('staff navlink', () => {

    //add

    it('checks if the admin can add tasks', () => {
        // cy.refreshDatabase();
        //change phone number so that it can not display phone number already in use
        cy.visit('/login');
        cy.get('#phone-number').type('0916665210');
        cy.get('#password').type('1234');
        cy.contains('button','Login').click();
        cy.assertRedirect('/dashboard');
        cy.get(':nth-child(3) > a > .flex').click()
        cy.get('a > .bg-primary').click()
        cy.get('#full-name').type('new task1');
        cy.get('#phone-number').type('0911223344');
        cy.get('#quantity').type('4');
        cy.get('#total-price').type(40)
        cy.get('#paid-amount').type(30)
        cy.get(':nth-child(2) > .multiselect > .multiselect__select').click()
        cy.contains('nati').click()
        cy.get(':nth-child(5) > .multiselect > .multiselect__tags').click()
        cy.contains('Photoshoot').click()
        cy.get('#role').select('Field')
        cy.get('#type').select('Normal')
        cy.get('#remark').type('remark')
        cy.get('#data_location').type('data location')
        cy.get('#description').type('description')
        cy.get('#package').select('Gold package')
        cy.get('#status').select('Ongoing')
        cy.get('#tax-yes').click()
        cy.get('#selection_date').type('2022-12-22')
        cy.get('#shot-date').type('2017-06-01T08:30')
        cy.get('#delivery-date').type('2017-06-01T08:30')
        cy.get('.btn-primary').click()

        
        //check if it contains the siccess information
    });



    });
