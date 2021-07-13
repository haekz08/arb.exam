export default [
  {
    _name: 'CSidebarNav',
    _children: [
      {
        _name: 'CSidebarNavItem',
        name: 'Dashboard',
        to: '/dashboard',
        icon: 'cil-speedometer'
      },
      {
        _name: 'CSidebarNavDropdown',
        name: 'User Management',
        route: '/user-management',
        icon: 'cil-people',
        items: [
          {
            name: 'Roles',
            to: '/user-management/roles',
          },
          {
            name: 'Users',
            to: '/user-management/users',
          },
        ]
      },
      {
        _name: 'CSidebarNavDropdown',
        name: 'Expense Management',
        route: '/expense-management',
        icon: 'cil-folder',
        items: [
          {
            name: 'Expense Categories',
            to: '/expense-management/expense-categories',
          },
          {
            name: 'Expenses',
            to: '/expense-management/expenses',
          },
        ]
      },
      {
          _name: 'CSidebarNavItem',
          name: 'Change Password',
          to: '/password-change',
          icon: 'cil-lock-locked'
      },
    ]
  }
]