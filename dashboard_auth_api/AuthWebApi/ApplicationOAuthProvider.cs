using AuthWebApi.Models;
using Microsoft.AspNet.Identity;
using Microsoft.AspNet.Identity.EntityFramework;
using Microsoft.Owin.Security;
using Microsoft.Owin.Security.OAuth;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using System.Web;

namespace AuthWebApi
{
    public class ApplicationOAuthProvider : OAuthAuthorizationServerProvider 
    {
        // Used for Authentication user device
        public override async Task ValidateClientAuthentication(OAuthValidateClientAuthenticationContext context)
        {
            context.Validated();
        }

        // Authenticate user based on his username and password
        public override async Task GrantResourceOwnerCredentials(OAuthGrantResourceOwnerCredentialsContext context)
        {
            var userStore = new UserStore<ApplicationUser>(new ApplicationDbContext());
            var manager = new UserManager<ApplicationUser>(userStore);

            // Find a user with given username and password
            var user = await manager.FindAsync(context.UserName, context.Password);
            
            if (user != null)
            {
                // Claims means a statement about the login user
                var identity = new ClaimsIdentity(context.Options.AuthenticationType);
                identity.AddClaim(new Claim("Username", user.UserName));
                identity.AddClaim(new Claim("RegionCode", user.RegionCode));
                identity.AddClaim(new Claim("RegionName", user.RegionName));
                //identity.AddClaim(new Claim("Email", user.Email));
                //identity.AddClaim(new Claim("FirstName", user.FirstName));
                //identity.AddClaim(new Claim("LastName", user.LastName));
                identity.AddClaim(new Claim("LoggedOn", DateTime.Now.ToString()));
                //var userRoles = manager.GetRoles(user.Id);
                //foreach (string roleName in userRoles)
                //{
                //    identity.AddClaim(new Claim(ClaimTypes.Role, roleName));
                //}
                //var additionalData = new AuthenticationProperties(new Dictionary<string, string>{
                //    { 
                //        "role", Newtonsoft.Json.JsonConvert.SerializeObject(userRoles)
                //    }
                //});
                //var token = new AuthenticationTicket(identity, additionalData);
                //context.Validated(token);
                context.Validated(identity);
            }
            else
                return;
        }

        public override Task TokenEndpoint(OAuthTokenEndpointContext context)
        {
            foreach (KeyValuePair<string, string> property in context.Properties.Dictionary)
            {
                context.AdditionalResponseParameters.Add(property.Key, property.Value);
            }

            return Task.FromResult<object>(null);
        }
    }
}