<template>
  <CHeader fixed with-subheader light>
    <CToggler
      in-header
      class="ml-3 d-lg-none"
      @click="$store.commit('toggleSidebarMobile')"
    />
    <CToggler
      in-header
      class="ml-3 d-md-down-none"
      @click="$store.commit('toggleSidebarDesktop')"
    />
    <CHeaderBrand class="mx-auto d-lg-none" to="/">
      <CIcon name="logo" height="48" alt="Logo"/>
    </CHeaderBrand>
    <CHeaderNav class="d-md-down-none mr-auto">
      
    </CHeaderNav>
    <CHeaderNav class="mr-4">
      <small>Welcome <strong>{{name}}</strong> !</small>
      <CHeaderNavItem class="d-md-down-none mx-2" @click.native="logout()">
        <CHeaderNavLink>
          <CIcon name="cil-lock-locked"/>
        </CHeaderNavLink>
      </CHeaderNavItem>
    </CHeaderNav>
    <CSubheader class="px-3">
      <CBreadcrumbRouter class="border-0 mb-0"/>
    </CSubheader>
  </CHeader>
</template>

<script>
import TheHeaderDropdownAccnt from './TheHeaderDropdownAccnt'
import SwalMixin from '@/views/mixins/Swal.js'

export default {
  name: 'TheHeader',
  mixins:[SwalMixin],
  components: {
    TheHeaderDropdownAccnt
  },
    computed: {
        name() {
            return this.$store.getters.userDetails.name;
        }
    },
  methods: {
      logout() {
        this.swal_confirm_submit_data.title="Are you sure you want to logout?";
        this.swal_confirm_submit_data.text="You will be redirected to the login page";
        this.swal_confirm_submit_data.confirmButtonText="Yes, log me out!";
        this.swalConfirmSubmit((data)=>{
            if (data.value) {
              this.$store.dispatch('logOutAction').then(response => {
                  this.$router.push('/login')
              })
            }
        });
      }
  }
}
</script>
