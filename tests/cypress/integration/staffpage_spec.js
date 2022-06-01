beforeEach(function(){
    cy.fixture('admincredential').then(function (adminData) {
        cy.log(adminData)
        this.adminData = adminData
    })
})
describe('staff navlink', () => {

//add

it('checks if the admin can add staff', () => {
    // cy.refreshDatabase();
    //change phone number so that it can not display phone number already in use
    cy.visit('/login');
    cy.get('#phone-number').type('0916665210');
    cy.get('#password').type('1234');
    cy.contains('button','Login').click();
    cy.assertRedirect('/dashboard');
    cy.get(':nth-child(2) > a > .flex').click()
    cy.contains("[data-cy='addStaff']", "Add Staff").click();
    cy.get('#full-name').type('staff to be deleted');
    cy.get('#phone-number').type('0911223344');
    cy.get('#role').select('staff');
    cy.get('.btn-primary').click();
});

it('checks if the admin can add admin', () => {
    // cy.refreshDatabase();
    cy.visit('/login');
    cy.get('#phone-number').type('0916665210');
    cy.get('#password').type('1234');
    cy.contains('button','Login').click();
    cy.assertRedirect('/dashboard');
    cy.get(':nth-child(2) > a > .flex').click()
    cy.get('a > .bg-primary').click()
    cy.get('#full-name').type('admin to be deleted');
    cy.get('#phone-number').type('0908080808');
    cy.get('#role').select('admin');
    cy.get('.btn-primary').click();
    cy.contains('User Added Successfully')

});
//make dynamically select admin


//edit

it('checks if the admin can edit staff', () => {
    // cy.refreshDatabase();
    cy.visit('/login');
    cy.get('#phone-number').type('0916665210');
    cy.get('#password').type('1234');
    cy.contains('button','Login').click();
    cy.assertRedirect('/dashboard');
    cy.get(':nth-child(2) > a > .flex').click()
    cy.get(':nth-child(1) > .text-gray-300 > a').click()
    cy.get('#full-name').clear().type('staff 1')
    cy.get('.btn-primary').click();
    cy.contains('User Updated Successfully');
});

it('checks if the admin can edit admin', () => {
    // cy.refreshDatabase();
    cy.visit('/login');
    cy.get('#phone-number').type('0916665210');
    cy.get('#password').type('1234');
    cy.contains('button','Login').click();
    cy.assertRedirect('/dashboard');
    cy.get(':nth-child(2) > a > .flex').click()
    cy.get(':nth-child(3) > .text-gray-300 > a').click()
    cy.get('#phone-number').clear().type('0909090909')
    cy.get('.btn-primary').click();
    cy.contains('User Updated Successfully');
});

//delete
it.only('checks if the admin can delete staff', () => {
    // cy.refreshDatabase();
    // cy.visit('/login');
    // cy.get('#phone-number').type('0916665210');
    // cy.get('#password').type('1234');
    // cy.contains('button','Login').click();
    cy.assertRedirect('/dashboard');
    cy.get(':nth-child(2) > a > .flex').click()
    // cy.get(':nth-child(2) > .text-gray-300 > [data-cy="addStaff"] > .hover\:text-red-400 > path').click()
    cy.get("[data-cy='deleteStaff']").last().click()
    cy.contains("Staff Deleted Successfully")
    // cy.contains('User Updated Successfully');
});

it.only('check stub and spy', () => {
    // cy.refreshDatabase();
    cy.intercept('GET','/api/users*',{
        statusCode: 200,
        body: {
                "data": [
                    {
                        "id": 13,
                        "name": "staff 1 intercepted",
                        "phone_number": "0911223344",
                        "role": "staff",
                        "created_at": "2022-05-30T07:36:34.000000Z",
                        "updated_at": "2022-06-01T00:09:33.000000Z"
                    },
                    {
                        "id": 15,
                        "name": "staff intercepted",
                        "phone_number": "0919298886",
                        "role": "staff",
                        "created_at": "2022-05-31T20:06:58.000000Z",
                        "updated_at": "2022-06-01T05:33:23.000000Z"
                    }
                ],
                "message": "Resource fetched successfully"
            
        }
    })

    cy.visit('/login');
    cy.get('#phone-number').type('0916665210');
    cy.get('#password').type('1234');
    cy.contains('button','Login').click();
    cy.assertRedirect('/dashboard');
    cy.get(':nth-child(2) > a > .flex').click();
    cy.contains('staff intercepted');
});

});
