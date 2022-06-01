describe('authentication', () => {
    before(function () {
        cy.fixture('admincredential').then(function (adminData) {
            cy.log(adminData)
            this.adminData = adminData
        })
    })
    // cy.log(this.adminData)
    before(function () {
        cy.fixture('staffCredentials').then(function (staffData) {
            this.staffData = staffData
        })
    })



    it('provides feedback for invalid credentials ', () => {
        // cy.refreshDatabase();

        cy.login("0909090909","5463")

        cy.contains('Authentication Failed');
    });

    

    it('signs in as admin ', () => {
        // cy.refreshDatabase();
        // cy.log(this.adminData);
        
        cy.fixture('admincredential').then(function (adminData) {
            cy.login(adminData.phoneNumber,adminData.password)
        })
        cy.assertRedirect('/dashboard');
    });


    it('signs in staff', () => {
        // cy.clearLocalStorage();

        cy.fixture('staffCredentials').then(function (staffData) {
            cy.login(this.staffData.phoneNumber,this.staffData.password)
        })
        cy.location('pathname').should('eq', '/calendar');
    });
});


//second


