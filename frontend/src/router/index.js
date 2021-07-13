import Vue from 'vue'
import Router from 'vue-router'

// Containers
const LoginContainer = () => import('@/containers/LoginContainer')
const TheContainer = () => import('@/containers/TheContainer')



const ExpenseManagement = () => import('@/views/expense-management/Index')
const Expenses = () => import('@/views/expense-management/expenses/All')
const ExpenseCategories = () => import('@/views/expense-management/expense-categories/All')

const UserManagement = () => import('@/views/user-management/Index')
const Users = () => import('@/views/user-management/users/All')
const Roles = () => import('@/views/user-management/roles/All')

Vue.use(Router)

export default new Router({
  //base:'/',
  base:'/',
  mode: 'history', // https://router.vuejs.org/api/#mode
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes()
})

function configRoutes () {
  return [
      {
          path: '/login',
          name: 'Login',
          component: LoginContainer
      },
      {
          path: '/',
          redirect: '/dashboard',
          name: 'Home',
          component: TheContainer,
          children: [
              {
                  path: '/dashboard',
                  name: 'DashBoard',
                  meta: {label: "Dashboard"},
                  props: true,
                  component: () => import('@/views/Dashboard')
              },
              {
                  path: '/password-change',
                  name: 'Change Password',
                  meta: {label: "Change Password"},
                  props: true,
                  component: () => import('@/views/ChangePassword')
              },
              {
                  path: '/expense-management',
                  redirect: '/expense-management/expenses',
                  name: 'Expense Management',
                  component: ExpenseManagement,
                  children: [
                      {
                          path: '/expense-management/expense-categories',
                          name: 'Expense Categories',
                          component: ExpenseCategories
                      },
                      {
                          path: '/expense-management/expenses',
                          name: 'Expenses',
                          component: Expenses
                      }
                  ]
              },
              {
                  path: '/user-management',
                  redirect: '/user-management/user',
                  name: 'User Management',
                  component: UserManagement,
                  children: [
                      {
                          path: '/user-management/users',
                          name: 'Users',
                          component: Users
                      },
                      {
                          path: '/user-management/roles',
                          name: 'Roles',
                          component: Roles
                      }
                  ]
              },
          ]
      }
      
  ]
}

