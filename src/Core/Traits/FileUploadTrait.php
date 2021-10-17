<?php
namespace App\Core\Traits;
use http\Exception\InvalidArgumentException;
/**
 * Trait FileUploadTrait.
 *
 * @ORM\HasLifecycleCallbacks()
 */
trait FileUploadTrait
{
    protected string $file;
    private string $fileName;
    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected string $path;
    /**
     * Sets file.
     *
     * @param  $file
     */
    public function setFile($file = null, $removable = false)
    {
        if ($file == null && !$removable) {
            $this->path = null;
        }


        $this->file     = $file;
        $this->updatedAt = new \DateTime();
    }
    public function getFile()
    {
        return $this->file;
    }
    public function getPath()
    {
        return $this->path;
    }
    /**
     * @param $path
     *
     * @return $this
     */
    public function setPath($path): self
    {

        $this->path = $path;

        return $this;
    }
    public function getRootDir()
    {
        return __DIR__;
    }
    public function getWebSubDir()
    {
        return 'uploads';
    }
    public function getWebDir()
    {
        return $this->getRootDir().\DIRECTORY_SEPARATOR.'..'.\DIRECTORY_SEPARATOR.'..'.\DIRECTORY_SEPARATOR.'..'.\DIRECTORY_SEPARATOR.'public'.\DIRECTORY_SEPARATOR.$this->getWebSubDir();
    }
    public function getRelativePath()
    {
        return $this->getUploadDir().\DIRECTORY_SEPARATOR.$this->path;
    }
    public function getRelativeUrl()
    {
        return $this->getWebSubDir().\DIRECTORY_SEPARATOR.$this->getUploadDir().\DIRECTORY_SEPARATOR.$this->path;
    }
    public function getAbsolutePath()
    {
        if ($this->path) {
            return $this->getWebDir().\DIRECTORY_SEPARATOR.$this->getRelativePath();
        }

        return null;
    }
    public function getAbsoluteUploadDir()
    {
        return $this->getWebDir().\DIRECTORY_SEPARATOR.$this->getUploadDir();
    }
    public function getFilters()
    {
        return ['_135x215', '_150x150', '_200x100', '_500x350', '_900x400'];
    }
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        if (\in_array($this->getFile()->getMimeType(), $this->getAllowedTypes(), true)) {
            if (!is_dir($this->getAbsoluteUploadDir())) {
                mkdir($this->getAbsoluteUploadDir(), 0777, true);
            }
            $this->deleteImages();
            $extension = $this->getExtension($this->getFile());
            $this->fileName = $this->getNamer();
            $this->setPath($this->fileName.'.'.$extension);
        }
    }
    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function moveFile()
    {
        $extension = $this->getExtension($this->getFile());
        $this->getFile()->move(
            $this->getAbsoluteUploadDir(),
            sprintf('%s.%s', $this->fileName, $extension)
        );

    /*    Image::open($this->getAbsoluteUploadDir()."/". sprintf('%s.%s', $this->fileName, $extension))
            ->resize(200, 200)
            ->save($this->getAbsoluteUploadDir()."/thumb_".sprintf('%s.%s', $this->fileName, $extension));*/

        $this->setFile(null, true);
    }
    public function recurseRmdir($dir)
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->recurseRmdir("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    }
    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath.'*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    public function deleteImages()
    {
        if ($this->path) {
            @unlink($this->getAbsolutePath());
            foreach ($this->getFilters() as $filter) {
                list($name, $extension) = explode('.', $this->getPath());
                @unlink($this->getAbsoluteUploadDir().\DIRECTORY_SEPARATOR.$name.$filter.'.'.$extension);
            }
        }
    }
    protected function getExtension($file): ?string
    {
        $originalName = $file->getClientOriginalName();

        if ($extension = pathinfo($originalName, PATHINFO_EXTENSION)) {
            return $extension;
        }

        if ($extension = $file->guessExtension()) {
            return $extension;
        }

        return null;
    }
    abstract public function getNamer();
    abstract public function getAllowedTypes();
    abstract public function getUploadDir();
}
