class Auth {
    constructor(user) {
        this.user = user;
        this.all = [
            'view-emprestimos',
            'create-emprestimos',
            'renew-emprestimos',
            'return-emprestimos',
            'view-acervo',
            'create-acervo',
            'edit-acervo',
            'delete-acervo',
            'view-autores',
            'create-autores',
            'edit-autores',
            'delete-autores',
            'view-estudantes',
            'create-estudantes',
            'edit-estudantes',
            'delete-estudantes',
            'view-secoes',
            'create-secoes',
            'edit-secoes',
            'delete-secoes',
            'view-editoras',
            'create-editoras',
            'edit-editoras',
            'delete-editoras',
            'view-relatorios'
        ];
        this.permissions = {
            usuario: [
                'view-acervo',
                'view-autores',
                'view-editoras',
            ],
            bibliotecario: this.all,
            admin: this.all
        };
    }

    can(action) {
        if (!this.user instanceof Object) {
            return false;
        }

        return this.permissions[this.user.grupo].indexOf(action) !== -1;
    }
}

export default Auth;