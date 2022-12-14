using AuthWebApi.Models;
using Microsoft.AspNet.Identity;
using Microsoft.AspNet.Identity.EntityFramework;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Security.Claims;
using System.Threading.Tasks;
using System.Web.Http;
using System.Web.Http.Cors;

namespace AuthWebApi.Controllers
{
    [EnableCors(origins: "http://localhost:4200", headers: "*", methods: "*")]
    //[EnableCorsAttribute("*","*","*")]
    public class AccountController : ApiController
    {
        [Route("api/user/register")]
        [HttpPost]
        [AllowAnonymous]
        public IdentityResult Register(AccountModel model)
        {
            var userStore = new UserStore<ApplicationUser>(new ApplicationDbContext());
            var manager = new UserManager<ApplicationUser>(userStore);

            var user = new ApplicationUser() { UserName = model.RegionCode, Email = model.Email };
            user.FirstName = model.FirstName;
            user.LastName = model.LastName;
            user.RegionCode = model.RegionCode;
            user.RegionName = model.RegionName;

            manager.PasswordValidator = new PasswordValidator
            {
                RequiredLength = 3
            };
            IdentityResult result = manager.Create(user, model.Password);
            
            //IdentityResult result = manager.Create(user, model.Password);
            // manager.AddToRoles(user.Id, model.Roles);
            return result;
        }

        [HttpGet]
        [Route("api/GetUserClaims")]
        public AccountModel GetUserClaims()
        {
            var identityClaims = (ClaimsIdentity)User.Identity;
            IEnumerable<Claim> claims = identityClaims.Claims;
            AccountModel model = new AccountModel()
            {
                UserName = identityClaims.FindFirst("Username").Value,
                //Email = identityClaims.FindFirst("Email").Value,
                //FirstName = identityClaims.FindFirst("FirstName").Value,
                //LastName = identityClaims.FindFirst("LastName").Value,
                RegionCode = identityClaims.FindFirst("RegionCode").Value,
                RegionName = identityClaims.FindFirst("RegionName").Value,
                LoggedOn = identityClaims.FindFirst("LoggedOn").Value
            };
            return model;
        }

        [HttpPost]
        [Route("api/change-password")]
        public async Task<IdentityResult> ChangePassword(ChangePasswordVM model)
        {
            IdentityResult result = null;
            var userStore = new UserStore<ApplicationUser>(new ApplicationDbContext());
            var manager = new UserManager<ApplicationUser>(userStore);
            manager.PasswordValidator = new PasswordValidator
            {
                RequiredLength = 3
            };

            var user = await manager.FindAsync(model.UserName, model.CurrentPassword);
            
            if(user != null)
            {
                result = await manager.ChangePasswordAsync(user.Id, model.CurrentPassword, model.NewPassword);
            }
            return result;
        }

        [HttpGet]
        [Authorize(Roles = "Admin")]
        [Route("api/ForAdminRole")]
        public string ForAdminRole()
        {
            return "for admin role";
        }

        [HttpGet]
        [Authorize(Roles = "Author")]
        [Route("api/ForAuthorRole")]
        public string ForAuthorRole()
        {
            return "For author role";
        }

        [HttpGet]
        [Authorize(Roles = "Author,Reader")]
        [Route("api/ForAuthorOrReader")]
        public string ForAuthorOrReader()
        {
            return "For author/reader role";
        }
    }
}
