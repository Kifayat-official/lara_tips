namespace AuthWebApi.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class ColumnPasswordRemoved : DbMigration
    {
        public override void Up()
        {
            DropColumn("dbo.User", "Password");
        }
        
        public override void Down()
        {
            AddColumn("dbo.User", "Password", c => c.String());
        }
    }
}
