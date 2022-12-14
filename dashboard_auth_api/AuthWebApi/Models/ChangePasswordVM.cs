using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace AuthWebApi.Models
{
    public class ChangePasswordVM
    {
        public string UserName { get; set; }
        public string CurrentPassword { get; set; }
        public string NewPassword { get; set; }
    }
}