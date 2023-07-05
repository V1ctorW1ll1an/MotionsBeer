using Microsoft.EntityFrameworkCore;

namespace App.Models;

public class DataBaseContext : DbContext
{
    public DataBaseContext(DbContextOptions<DataBaseContext> options)
        : base(options) { }

    public DbSet<Usuario> Usuarios { get; set; } = null!;

    public DbSet<OrdemProducao> OrdensProducao { get; set; } = null!;
}
