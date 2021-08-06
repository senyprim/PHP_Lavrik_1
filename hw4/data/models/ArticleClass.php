class ArticleClass{
    protected $id;
    protected $title;
    protected $content;
    protected $dt_add;
    protected $categry;
    protected $user;

    public function __construct($id, $title, $content, $dt_add, $categry, $user)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->dt_add = $dt_add;
        $this->categry = $categry;
        $this->user = $user;
    }
}