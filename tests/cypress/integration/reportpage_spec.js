
describe('create a report', () => {
    it('the admin should be able to create a report', () => {
        //create a custom function that changes password if the authentication fails
        // cy.refreshDatabase();
        cy.visit('/login');
        cy.get('#phone-number').type('0916665210');
        cy.get('#password').type('1234');
        cy.contains('button','Login').click();
        cy.contains('Report').click();
        cy.contains('Add daily report').click();
        cy.get('#income-amount').type('2345')
        cy.get('#income-description').type('1234')
        cy.get('#expense_amount').type('1234')
        cy.get('#expense-description').type('hello')
        cy.get('#location').type('2022-12-22')
        cy.get('.btn-primary').click();
        cy.contains('Report Added Successfully');
    });

    it('the admin should be able to create a report', () => {
        //create a custom function that changes password if the authentication fails
        // cy.refreshDatabase();
        cy.visit('/login');
        cy.get('#phone-number').type('0916665210');
        cy.get('#password').type('1234');
        cy.contains('button','Login').click();
        cy.contains('Report').click();
        cy.get(':nth-child(1) > .text-gray-300 > a > .mr-2 > path').click()
        cy.get('#income-amount').clear().type('test1')
        cy.get('.btn-primary').click()
        cy.contains('Report Added Successfully')

    });
    it.only('delete report from the reports' , ()=>{
        cy.visit('/login');
        cy.get('#phone-number').type('0916665210');
        cy.get('#password').type('1234');
        cy.contains('button','Login').click();
        cy.contains('Report').click();
        cy.get(`.main>div`)
    .contains('svg', 'Header element')
    })
});


//second


