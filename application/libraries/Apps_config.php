<?php class Apps_config
{
    protected $CI;
    protected $setting;

    public function __construct()
    {
        $this->CI = &get_instance();
    }
    
    public function apps_config()
    {
        $this->CI->load->config('apps_ujian');
        $dinamic = $this->CI->db->select('nama, isi')->get('apps_setting')->result();
        if(!empty($dinamic)) {
            foreach ($dinamic as $item) {
                $this->CI->config->set_item($item->nama, $item->isi);
            }
        }
        return;
    }

}
