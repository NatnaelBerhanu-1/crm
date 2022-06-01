describe('staff navlink', () => {

    //add
    
    it('checks if the admin can add Inventory', () => {
        // cy.refreshDatabase();
        //change phone number so that it can not display phone number already in use
        cy.visit('/login');
        cy.get('#phone-number').type('0916665210');
        cy.get('#password').type('1234');
        cy.contains('button','Login').click();
        cy.assertRedirect('/dashboard');
        cy.get(':nth-child(4) > a > .flex').click()
        cy.contains("Add Item").click();
        cy.get('#name').type('inventory name 1')
        cy.get('#description').type('inventory description 1')
        cy.get('#price').type('20')
        cy.get('#location').type('inventory location 1')
        cy.get('#condition').type('inventory condition 1')
        cy.get('#remark').type('inventory remark 1')
        cy.get("[data-cy='addInventory']").click()
        cy.contains('Inventory Added Successfully')
        // cy.get('#full-name').type('staff to be deleted');
        // cy.get('#phone-number').type('0911223344');
        // cy.get('#role').select('staff');
        // cy.get('.btn-primary').click();
    });
    //edit
    it('checks if the admin can edit Inventory', () => {
        // cy.refreshDatabase();
        //change phone number so that it can not display phone number already in use
        cy.visit('/login');
        cy.get('#phone-number').type('0916665210');
        cy.get('#password').type('1234');
        cy.contains('button','Login').click();
        cy.assertRedirect('/dashboard');
        cy.get(':nth-child(4) > a > .flex').click()
        cy.get(':nth-child(1) > .text-gray-300 > a').click()
        cy.get('#name').clear().type('inventory 2')
        cy.get('.btn-primary').click()
        cy.contains('Inventory Updated Successfully');
        // cy.get('#full-name').type('staff to be deleted');
        // cy.get('#phone-number').type('0911223344');
        // cy.get('#role').select('staff');
        // cy.get('.btn-primary').click();
    });

    it.only('checks if the admin can delete Inventory', () => {
        // cy.refreshDatabase();
        //change phone number so that it can not display phone number already in use
        cy.visit('/login');
        cy.get('#phone-number').type('0916665210');
        cy.get('#password').type('1234');
        cy.contains('button','Login').click();
        cy.assertRedirect('/dashboard');
        cy.get(':nth-child(4) > a > .flex').click()
        cy.get("[data-cy='deleteInventory']").last().click()
        cy.contains("Inventory Deleted Successfully")
        // cy.get('#full-name').type('staff to be deleted');
        // cy.get('#phone-number').type('0911223344');
        // cy.get('#role').select('staff');
        // cy.get('.btn-primary').click();
    });
    
    
    });
    